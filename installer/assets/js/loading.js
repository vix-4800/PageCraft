document.addEventListener("DOMContentLoaded", () => {
	const progressBar = document.getElementById("progress_bar");
	const progressStatus = document.getElementById("progress_status");

	const installedSection = document.getElementById("installed_content");

	setInterval(async () => {
		if (progressBar.value === 100) {
			return;
		}

		const response = await fetch("handler.php?get=status");

		if (response.ok) {
			const data = await response.json();

			const progress = Number.parseFloat(data.progress);

			progressBar.value = progress;
			progressStatus.textContent = data.status;

			if (progress === 100) {
				installedSection.classList.remove("hidden");

				progressStatus.classList.add("hidden");
				progressBar.classList.add("hidden");
			}
		} else {
			progressStatus.textContent = "Error fetching status.";
		}
	}, 1500);
});
