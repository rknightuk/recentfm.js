const nowCurrentScript = document.currentScript
const urlParams = new URLSearchParams(nowCurrentScript.src.split('.js')[1])
const params = Object.fromEntries(urlParams.entries())

if (params.u)
{
    const emoji = params.e ? params.e : '🎧'
    const path = `https://recentfm.rknight.me/now.php?username=${params.u}&emoji=${emoji}`
    fetch(path)
    .then((response) => response.json())
    .then((data) => {
        console.log(data)
        nowcontainer = document.createElement('div')
        nowcontainer.className = 'recent-played'
        nowcontainer.style
        nowcontainer.innerHTML = `${data.content}`
        nowCurrentScript.parentNode.insertBefore(nowcontainer, nowCurrentScript)
    })
}
