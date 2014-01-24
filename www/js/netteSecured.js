jQuery(function($) {
	$(document).on("click", "a[data-nette-csrf-token]", function(event) {
		var form = document.createElement("form");
		form.method = "POST";
		form.action = this.href;
		form.style.display = "none";
		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", "__token__");
		input.setAttribute("value", $(this).data("nette-csrf-token"));
		form.appendChild(input);
		$(form).submit();
		event.preventDefault();
	});
});
