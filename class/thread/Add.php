<?php
namespace oc\ext\groups\thread ;

use oc\mvc\view\View;
use jc\verifier\NotEmpty;
use oc\base\FrontFrame;
use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use oc\mvc\controller\Controller ;
use oc\mvc\model\db\Model;
use jc\mvc\model\db\orm\PrototypeAssociationMap;
use jc\verifier\Email;
use jc\verifier\Length;
use jc\verifier\NotNull;
use jc\mvc\view\widget\Text;
use jc\mvc\view\widget\Select;
use jc\mvc\view\widget\CheckBtn;
use jc\mvc\view\widget\RadioGroup;
use jc\message\Message ;
use jc\mvc\view\DataExchanger ;


/**
 * Enter description here ...
 * @author gaojun
 *
 */
class Add extends Controller
{
	protected function init()
	{
		$this->createFormView("ThreadForm", "thread.add.html") ;
		
		
	    // 为视图创建控件
		$this->viewThreadForm->addWidget( new Text("title","标题","",Text::single), 'title' )->addVerifier( NotEmpty::singleton (), "请说点什么" ) ;
		$this->viewThreadForm->addWidget( new Text("content","群组","",Text::multiple), 'content' )->addVerifier( NotEmpty::singleton (), "请说点什么" ) ;
		
		$this->oSelect = new Select ( 'group', '选择类型' );
		$this->oSelect->addOption ( "请选择", null, true) ;
		$this->oSelect->addVerifier( NotEmpty::singleton (), "请选择类型" );
		
		$this->viewThreadForm->addWidget ( $this->oSelect, 'gid' );
			
		if($this->aParams->get("t")=="")
		{
			$this->model = Model::fromFragment('thread');
			
		}
		elseif ($this->aParams->get("t")=="poll")
		{
			$this->viewThreadForm->add(
				new View("Poll", "thread.add.poll.html")
			);
			
			
			$this->viewThreadForm->viewPoll->addWidget ( new Select ( 'poll_maxitem', '选择数量' ), 'poll.maxitem' )
								->addOption ( "不限制", "0", true)
								->addOption ( "最多2项", "2" )
								->addOption ( "最多3项", "3" )
						->addVerifier( NotEmpty::singleton (), "请选择数量" ) ;
						
			$this->viewThreadForm->viewPoll->addWidget( new Text("poll_item_title","投票内容","",Text::single), 'item.title' )->addVerifier( NotEmpty::singleton (), "请说点什么" ) ;
			
			$this->model = Model::fromFragment('thread',array("poll"=>array("item")));
		}
		
		
		//设置model
		$this->viewThreadForm->setModel($this->model) ;
		$this->viewThreadForm->viewPoll->setModel($this->model) ;
		
	}
	
	public function process()
	{
		$this->requireLogined() ;
		
		$oUserModel = Model::fromFragment('user',array("group"),true);
		$oUserModel->load(IdManager::fromSession()->currentId()->userId(),"uid");
		//$oUserModel->printStruct();
		
		foreach ($oUserModel->childIterator() as $row){
			$this->oSelect	->addOption ($row->child("group")->data("name"),$row->child("group")->data("gid"));
		}
		
		
		if( $this->viewThreadForm->isSubmit( $this->aParams ) )
		{
            // 加载 视图窗体的数据
            $this->viewThreadForm->loadWidgets( $this->aParams ) ;
            
            // 校验 视图窗体的数据
            if( $this->viewThreadForm->verifyWidgets() )
            {
            	$this->viewThreadForm->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            	
				$this->viewThreadForm->model()->setData('uid',IdManager::fromSession()->currentId()->userId()) ;
				$this->viewThreadForm->model()->setData('time',time()) ;
				
				if($this->aParams->get("t") == "poll")
				{
					//echo "<pre>";print_r($this->viewThreadForm->model()->printStruct());echo "</pre>";exit;
				    $item = $this->viewThreadForm->model()->child('poll')->child('item')->createChild();
				    $item->setData("title",'sss');
				}
				
            	try {
            		if( $this->viewThreadForm->model()->save() )
            		{
            			$this->viewThreadForm->createMessage( Message::success, "发布成功！" ) ;
            			$this->viewThreadForm->hideForm() ;
            		}
            		else 
            		{
            			$this->viewThreadForm->createMessage( Message::failed, "遇到错误！" ) ;
            		}
            			
            	} catch (ExecuteException $e) {
            			throw $e ;
            	}
           	}
		}
	}
}

?>