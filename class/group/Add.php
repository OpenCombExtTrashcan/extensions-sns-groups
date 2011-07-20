<?php
namespace oc\ext\groups\group ;

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
		$this->createView("Add", "group.add.html",true) ;
		
		// 为视图创建控件
		$this->viewAdd->addWidget( new Text("name","名称","",Text::single), 'name' )->addVerifier( NotEmpty::singleton (), "请说点什么" ) ;
		
		$this->viewAdd->addWidget ( new Select ( 'type', '选择类型'), 'type' )
								->addOption ( "请选择", null, true)
								->addOption ( "同学", "tx" )
								->addOption ( "师生", "ss" )
								->addOption ( "社会", "sh" )
								->addVerifier( NotEmpty::singleton (), "请选择类型" ) ;
						
						
		$this->model = Model::fromFragment('group');
		
		//设置model
		$this->viewAdd->setModel($this->model) ;
		
	}
	
	public function process()
	{
	
		if( $this->viewAdd->isSubmit( $this->aParams ) )
		{
            // 加载 视图窗体的数据
            $this->viewAdd->loadWidgets( $this->aParams ) ;
            
            // 校验 视图窗体的数据
            if( $this->viewAdd->verifyWidgets() )
            {
            	$this->viewAdd->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            	
				$this->viewAdd->model()->setData('uid',IdManager::fromSession()->currentId()->userId()) ;
				$this->viewAdd->model()->setData('time',time()) ;
				
            	try {
            		if( $this->viewAdd->model()->save() )
            		{
            			$this->viewAdd->createMessage( Message::success, "发布成功！" ) ;
            			$this->viewAdd->hideForm() ;
            		}
            		else 
            		{
            			$this->viewAdd->createMessage( Message::failed, "遇到错误！" ) ;
            		}
            		
            			
            	} catch (ExecuteException $e) {
            			throw $e ;
            	}
           	}
		}
	}
}

?>