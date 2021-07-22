const { apiFetch } = wp;

export function fetchLatestMostViewedPosts(args = {}){
	var headers = new Headers();
	headers.append("Content-Type", "application/json");

	return apiFetch( {
		path: `/posts-views/v1/posts` ,
		method: 'POST',
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			show: 5,
			days_ago: null, // usar valor de la configuración
			...args,
		}),
	} )
		.then( ( result ) => {
			return result;
		});
}
