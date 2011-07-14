	<div>
		最多选择：<?php echo eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->data('poll.maxitem');") ;?>
	</div>
	<?php if(eval("if(!isset(\$__uivar_isInvolved)){ \$__uivar_isInvolved=&\$aVariables->getRef('isInvolved') ;};
return \$__uivar_isInvolved!=1;")){ ?>
	<div id="items">
		<?php
				$__foreach_Arr_var0 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->child('poll')->child('item')->childIterator();");
				if(!empty($__foreach_Arr_var0)){ 
					$__foreach_idx_var3 = -1;
					foreach($__foreach_Arr_var0 as $__foreach_key_var2 => &$__foreach_item_var1){
						$__foreach_idx_var3++;
						 $aVariables->set("row",$__foreach_item_var1 );  $aVariables->set("i",$__foreach_idx_var3 ); ?>
		<div>
			<span class='itemContent'>投票内容<?php echo eval("if(!isset(\$__uivar_i)){ \$__uivar_i=&\$aVariables->getRef('i') ;};
return \$__uivar_i+1;") ;?></span>：<input type="checkbox" class="items" name="item[]" id="item[]" value="<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('iid');") ;?>" onClick="checkItemSum(this)" /><?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('title');") ;?>
		</div>
		<?php 
					}
				}
			 		?>
	</div>
	<?php
					}else{
					?>
	<div id="items">
		<?php
				$__foreach_Arr_var4 = eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->child('poll')->child('item')->childIterator();");
				if(!empty($__foreach_Arr_var4)){ 
					$__foreach_idx_var7 = -1;
					foreach($__foreach_Arr_var4 as $__foreach_key_var6 => &$__foreach_item_var5){
						$__foreach_idx_var7++;
						 $aVariables->set("row",$__foreach_item_var5 );  $aVariables->set("i",$__foreach_idx_var7 ); ?>
		<div>
			<span class='itemContent'>投票内容<?php echo eval("if(!isset(\$__uivar_i)){ \$__uivar_i=&\$aVariables->getRef('i') ;};
return \$__uivar_i+1;") ;?></span>：<?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('title');") ;?> 票数: <?php echo eval("if(!isset(\$__uivar_row)){ \$__uivar_row=&\$aVariables->getRef('row') ;};
return \$__uivar_row->data('votes');") ;?>
		</div>
		<?php 
					}
				}
			 		?>
	</div>
	<?php } ?>
	<script>
	function checkItemSum(obj){
		var sum=0;
		if(jQuery(obj).attr("checked")=="checked"){
			
			jQuery(".items").each(function(i,v){
				if(jQuery(v).attr("checked")=="checked"){
					sum++;
				}
			});
			
			if(sum > <?php echo eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->data('poll.maxitem');") ;?>){
				alert("超出");
				jQuery(obj).removeAttr("checked");
			}
		}
	}
	</script>
	<?php if(eval("if(!isset(\$__uivar_isInvolved)){ \$__uivar_isInvolved=&\$aVariables->getRef('isInvolved') ;};
return \$__uivar_isInvolved!=1;")){ ?>
	<input type="hidden" id="t" name="t" value="<?php echo eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('t');") ;?>" />
	<input type="hidden" id="id" name="id" value="<?php echo eval("if(!isset(\$__uivar_theRequest)){ \$__uivar_theRequest=&\$aVariables->getRef('theRequest') ;};
return \$__uivar_theRequest->get('tid');") ;?>" />
	<input type="hidden" id="maxitem" name="maxitem" value="<?php echo eval("if(!isset(\$__uivar_theModel)){ \$__uivar_theModel=&\$aVariables->getRef('theModel') ;};
return \$__uivar_theModel->data('poll.maxitem');") ;?>" />
	<input type="submit" value="submit" />
	<?php } ?>