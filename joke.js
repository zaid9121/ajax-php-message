
document.getElementById('jokeButton').addEventListener('click', fetchJoke);

function fetchJoke() {
const xhr = new XMLHttpRequest();
const url = 'https://official-joke-api.appspot.com/random_joke'; // API URL

xhr.open('GET', url, true);

xhr.onload = function() {
if (xhr.status === 200) {
const jokeData = JSON.parse(xhr.responseText);
const joke = `${jokeData.setup} - ${jokeData.punchline}`;
document.getElementById('joke').textContent = joke;
} else {
document.getElementById('joke').textContent = 'Error fetching joke!';
}
};

xhr.onerror = function() {
document.getElementById('joke').textContent = 'Request error!';
};

xhr.send();
}
