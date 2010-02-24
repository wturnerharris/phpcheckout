<form id="form1" name="form1" enctype="multipart/form-data" action="uploader.php" method="POST">
	<label>Hidden (ID) <input type="hidden" name="hidden1" value="500" /></label>
	<p><label> Name: <input type="text" name="textfield" /></label>
	<p><label>Image: <input type="file" /></label>
	<p><label>Needs Repair: <input type="checkbox" name="checkbox2" value="checkbox" /></label>
	<p><label>Genre: <input type="text" name="textfield4" /> </label>
	(Ideally this is a drop down box with pre-populated results, possibly from a different table.)
	<p><label>Check Hours: <input type="text" name="textfield5" /></label>
	<p><label>Serial #: <input type="text" name="textfield6" /></label>
	<p><label>Model #: <input type="text" name="textfield7" /></label>
	<p><label>Thumbnail: <input type="file" /></label>
	<p><label>Special Contract Required: <input type="checkbox" name="checkbox" value="checkbox" /></label>
  <p><label>Notes: <textarea name="textarea"></textarea></label>    
	<p>
	  <input type="submit" name="Submit3" value="Submit" />
	  <input type="hidden" name="MAX_FILE_SIZE" value="500" />
    </form>