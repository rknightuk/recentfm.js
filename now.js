const nowCurrentScript = document.currentScript
const urlParams = new URLSearchParams(nowCurrentScript.src.split('.js')[1])
const params = Object.fromEntries(urlParams.entries())

if (params.a)
{
    const style = params.pretty === '' ? 'background: #e7f5ff; padding: 10px; border-radius: 10px' : ''
    const path = `https://omgnow.rknight.me/now.php?address=${params.a}`
    fetch(path)
    .then((response) => response.json())
    .then((data) => {
        nowcontainer = document.createElement('div')
        nowcontainer.className = 'now_container'
        nowcontainer.style
        nowcontainer.innerHTML = `<div class="now_content" style="${style}">${data.content}</div>`
        nowCurrentScript.parentNode.insertBefore(nowcontainer, nowCurrentScript)
    })
}
