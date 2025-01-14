document.addEventListener("DOMContentLoaded", () => {
	document
		.getElementById("installer-form")
		.addEventListener("submit", async (e) => {
			e.preventDefault();

			const formData = new FormData(e.target);

			const response = await fetch("handler.php", {
				method: "POST",
				body: formData,
			});

			if (response.ok) {
				window.location.href = "installing.php";
			} else {
				const errorText = await response.text();
				alert("An error occurred: " + errorText);
			}
		});

	const navLinks = document.getElementsByClassName("nav-link");
	Array.prototype.forEach.call(navLinks, function (link) {
		link.addEventListener("click", () => {
			setActiveLink(link);
		});
	});

	function setActiveLink(link) {
		Array.prototype.forEach.call(navLinks, function (link) {
			link.classList.remove("font-bold");
		});

		link.classList.add("font-bold");
	}
});
