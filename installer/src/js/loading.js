document.addEventListener("DOMContentLoaded", () => {
	setInterval(() => {
		fetch("/install.php?status=1").catch((error) => {
			console.error("Error:", error);
		});
	}, 1000);
});
