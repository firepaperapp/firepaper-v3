<div>
	<h1><?php echo $commentdata['Whiteboard']['title'] ?></h1>
</div>
<br>
<div>
	<?php echo $commentdata['Whiteboard']['content'] ?>
</div>

<br><br>

<p><strong>Comments</strong></p><br>

<?php echo $this->Form->create() ?>
	<div>
		<textarea name="whiteboardcomment" id="whiteboardcomment" ></textarea><br>
		<?php echo $this->Form->submit('submit',array('label'=>false,'name'=>'submit','value'=>'Submit',));?>
	</div>
</form>