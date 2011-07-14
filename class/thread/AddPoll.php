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
class AddPoll extends Controller
{
	protected function init()
	{
		$this->model = Model::fromFragment('poll_item');
	}
	
	public function process()
	{
		$aItems = $this->aParams->get("item");
		for($i = 0; $i < sizeof($aItems); $i++)
		{
			$this->model->load($aItems[$i],"iid");
			$this->model->setData('votes',$this->model->data("votes")+1) ;
			$this->model->save();
		}
		
		setcookie("webos_sns_poll_".$this->aParams->get("id"), IdManager::fromSession()->currentId()->userId() , time()+3600*24*365); /* 有效期1个小时 */
		Relocater::locate("/?c=groups.index", "投票成功") ;
	}
}

?>