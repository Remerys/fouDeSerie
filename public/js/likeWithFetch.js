var lesLiens = document.getElementsByClassName('likes')

for (var i = 0; i < lesLiens.length; i++) {
    addEventListener('click', majLike)
}

function majLike(event) {
    event.preventDefault()

    let baliseA = event.target.parentNode

    let url = baliseA.getAttribute('href')

    fetch(url).then(function(response) {
        if (response.ok) {
            return response.json()
        }
    }).then(function(data){
        baliseA.children[1].textContent = data.likes
    }).catch(function(error) {
        console.log('error', error)
    })
}
