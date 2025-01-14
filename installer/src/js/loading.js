document.addEventListener("DOMContentLoaded", () => {
	setInterval(() => {
		fetch("/install.php?get=status").catch((error) => {
			console.error("Error:", error);
		});
	}, 1000);
});
