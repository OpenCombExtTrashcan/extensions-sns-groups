<?php
namespace oc\ext\groups\thread ;

use jc\mvc\controller\Relocater;

use oc\mvc\view\View;

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
use jc\verifier\NotEmpty;
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
class Detail extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;

		//创建视图
		$this->createView("defaultView", "thread.detail.html",true) ;
		
		
		// 为视图创建控件
		$this->defaultView->addWidget( new Text("content","群组","",Text::multiple), 'content' )->addVerifier( NotEmpty::singleton (), "请说点什么" ) ;
		
		$this->oSelect = new Select ( 'group', '选择类型');
		$this->oSelect->addOption ( "请选择", null, true) ;
		$this->oSelect->addVerifier( NotEmpty::singleton (), "请选择类型" );
		
		$this->defaultView->addWidget ( $this->oSelect, 'gid' );
		
		if($this->aParams->get("t")=="thread")
		{
			$this->model = Model::fromFragment('thread');
			
		}
		elseif ($this->aParams->get("t")=="poll")
		{
			$this->defaultView->add(
				$this->pollView = new View("pollView", "thread.detail.poll.html")
			);
			
			
			$this->pollView->addWidget ( new Select ( 'poll_maxitem', '选择数量'), 'poll.maxitem' )
								->addOption ( "不限制", "0", true)
								->addOption ( "最多2项", "2" )
								->addOption ( "最多3项", "3" )
						->addVerifier( NotEmpty::singleton (), "请选择数量" ) ;
			
			$this->model = Model::fromFragment('thread',array("poll"=>array("item")));
			$this->pollView->setModel($this->model) ;
			
			//是否投过
			$this->pollView->variables()->set("isInvolved",@$_COOKIE["webos_sns_poll_".$this->aParams->get("tid")]);
		}
		
		//设置model
		$this->defaultView->setModel($this->model) ;
		
	}
	
	public function process()
	{
		
		$this->defaultView->model()->load($this->aParams->get("tid"),"tid");
		$this->defaultView->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
	}
}

?>