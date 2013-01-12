$(function() {
	$("form.login").submit(function() {
		var key = $("[name=key]", $(this)).val();
		$("[name=key]", $(this)).val(hex_md5(key));
		return true;
	});
});
