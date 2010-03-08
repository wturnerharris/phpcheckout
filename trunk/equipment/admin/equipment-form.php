<form id="frmEquipment" name="frmEquipment" enctype="multipart/form-data" action="uploader.php" method="POST">
	<label>Hidden (ID) <input type="hidden" name="hidden1" value="500" /></label>
	<p><label> Name: </label><input type="text" name="textfield" />
	<p><label>Image: </label><input type="file" />
	<p><label>Needs Repair: </label><input type="checkbox" name="checkbox2" value="checkbox" />
	<p><label>Genre: </label><input type="text" name="textfield4" /> 
	(Ideally this is a drop down box with pre-populated results, possibly from a different table.)
	<p><label>Check Hours: </label><input type="text" name="textfield5" />
	<p><label>Serial #: </label><input type="text" name="textfield6" />
	<p><label>Model #: </label><input type="text" name="textfield7" />
	<p><label>Thumbnail: </label><input type="file" />
	<p><label>Special Contract Required: </label><input type="checkbox" name="checkbox" value="checkbox" />
  <p><label>Notes: </label><textarea name="textarea"></textarea>
	<p>
	  <input type="submit" name="Submit3" value="Submit" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="500" />
    </form>