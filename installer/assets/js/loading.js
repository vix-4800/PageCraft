document.addEventListener("DOMContentLoaded", () => {
	const progressBar = document.getElementById("progress_bar");
	const progressStatus = document.getElementById("progress_status");

	setInterval(async () => {
		if (progressBar.value === 100) {
			return;
		}

		const response = await fetch("handler.php?get=status");

		if (response.ok) {
			const data = await response.json();
			progressBar.value = Number.parseFloat(data.progress);
			progressStatus.textContent = data.status;
		} else {
			progressStatus.textContent = "Error fetching status.";
		}
	}, 1500);
});
