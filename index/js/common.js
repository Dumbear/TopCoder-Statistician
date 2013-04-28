$(function() {
	$("form.login").submit(function() {
		var key = $("[name=key]", $(this)).val();
		$("[name=key]", $(this)).val(hex_md5(key));
		return true;
	});

	$("a.view-source-code").click(function() {
		var dialog = $("#dialog-modal");
		dialog.html("");
		dialog.dialog({
			title: "Source code",
			width: 800,
			minWidth: 400,
			maxWidth: 800,
			minHeight: 300,
			maxHeight: 600,
			modal: true
		});
		var url = $(this).attr("href");
		var language = $(this).attr("language");
		$.get(url, function(data) {
			dialog.html("<pre class=\"source-code sh_" + language + "\">" + data + "</pre>");
			dialog.dialog("option", "position", {my: "center", at: "center", of: window});
			sh_highlightDocument("shjs/lang/", ".min.js");
		});
		return false;
	});

	sh_highlightDocument("shjs/lang/", ".min.js");
});
