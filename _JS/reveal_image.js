const $images = document.querySelectorAll('.revealing-image');

$images.forEach(($image) => {
	$image.animate(
		{
			opacity: [0, 1],
			clipPath: ['inset(45% 20% 45% 20%)', 'inset(0% 0% 0% 0%)'],
		},
		{
			fill: 'both',
			timeline: new ViewTimeline({
				subject: $image,
			}),
			rangeStart: 'entry 25%',
			rangeEnd: 'cover 50%',
		}
	);
});