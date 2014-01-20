<?php
	// Change this to your timezone
	date_default_timezone_set('Asia/Jakarta');
	require '../../system/includes/dispatch.php';
	config('source', '../../admin/config.ini');
	include '../includes/session.php';

	if(isset($_POST['submit'])) {
		$post_date = date('Y-m-d-H');
		$post_tag = $_POST['tag'];
		$post_url = $_POST['url'];
		$post_content = $_POST['content'];
	}
	if(!empty($post_tag) && !empty($post_url) && !empty($post_content)) {
		$user = $_SESSION['user'];
		$filename = $post_date . '_' . $post_tag . '_' . $post_url . '.md';
		$dir = '../../content/' . $user. '/blog/';
		if(is_dir($dir)) {
			file_put_contents($dir . $filename, print_r($post_content, true));
		}
		else {
			mkdir($dir, 0777, true);
			file_put_contents($dir . $filename, print_r($post_content, true));
		}
		header('location: ../index.php');
	}
	if (login()) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create post</title>
	<link rel="stylesheet" type="text/css" href="../resources/style.css" />
	<link rel="stylesheet" type="text/css" href="../editor/css/editor.css" />
	<script type="text/javascript" src="../editor/js/Markdown.Converter.js"></script>
    <script type="text/javascript" src="../editor/js/Markdown.Sanitizer.js"></script>
    <script type="text/javascript" src="../editor/js/Markdown.Editor.js"></script>
</head>
<body>
<div class="wrapper-outer">
<div class="wrapper-inner">
	<div class="nav">
		<a href="<?php echo config('site.url');?>" target="_blank">Home</a> | 
		<a href="<?php echo config('site.url');?>/admin">Admin</a> | 
		<a href="../includes/logout.php">Logout</a> | 
		<span class="welcome">Welcome <?php echo $_SESSION['user'];?>!</span>
	</div>
	<div class="wmd-panel">
		<form method="POST">
			Tag: <br><input type="text" name="tag"/><br><br>
			Url: <br><input type="text" name="url"/><br><br>
			<div id="wmd-button-bar" class="wmd-button-bar"></div>
			<textarea id="wmd-input" class="wmd-input" name="content" cols="20" rows="10"></textarea><br/>
			<input type="submit" name="submit" value="Publish"/>
		</form>
	</div>
	<div id="wmd-preview" class="wmd-panel wmd-preview"></div>
	<script type="text/javascript">
	(function () {
		var converter = Markdown.getSanitizingConverter();
		
		converter.hooks.chain("preBlockGamut", function (text, rbg) {
			return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
				return "<blockquote>" + rbg(inner) + "</blockquote>\n";
			});
		});
		
		var editor = new Markdown.Editor(converter);
		
		editor.run();
	})();
	</script>
</div>
</div>	
</body>
</html>
<?php } else {header('location: ../index.php');} ?>