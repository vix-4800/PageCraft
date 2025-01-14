document.addEventListener("DOMContentLoaded", () => {
	const progressElement = document.getElementById("progress_bar");
	const progressStatus = document.getElementById("progress_status");

	setInterval(async () => {
		const response = await fetch("/install.php?get=status");

		if (response.ok) {
			const status = await response.text();
			progressStatus.textContent = status;
		}
	}, 1500);
});
