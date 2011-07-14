
<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView;") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
	$__ui_msgqueue->display($this,$aDevice) ;
} ?>

<?php if( !($aVariables->get('theView') instanceof \jc\mvc\view\FormView) or $aVariables->get('theView')->isShowForm() ) { ?>
<form action="/?c=groups.thread.addpoll" method="post">
	<div>
		群组：<?php echo eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->data('title');") ;?>
	</div>
	<div>
		内容：<?php echo eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->data('content');") ;?>
	</div>
	<?php ob_flush() ;
$theView = $aVariables->get('theView') ;
foreach($theView->iterator() as $aChildView){
	$theView->outputStream()->write($aChildView->outputStream()) ;
}?>
<input type="hidden" name="<?php echo $aVariables->get('theView')->htmlFormSignature()?>" value="1" /></form><?php } ?>
