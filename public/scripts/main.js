let visit = (site) => {
    window.open(site, '_blank')
}

let elasticNav = () => {
    let scrollY = window.scrollY.toString()
    let presetPadding = 10
    let factor = 0
    if (scrollY < 100) {
        factor = (100 - scrollY) / 100
    }
        
    let navDivs = document.getElementsByClassName('nav-sect')
    for (let i = 0; i < navDivs.length; i++){
        navDivs[i].style.marginTop = (presetPadding * factor).toFixed(0) + 'px'
        navDivs[i].style.marginBottom = (presetPadding * factor).toFixed(0) + 'px'
    }

    let alpha = 1 - factor
    let nav = document.getElementById('navbar')
    nav.style.backgroundColor = `rgba(218, 218, 218, ${alpha})` //rgb for 'shaddy' color
}

let backToTop = () => {
    let btnToTop = document.getElementById('scrollToTop')
    let scrollY = window.scrollY.toString()
    let scrolledPixelsBeforeBtnAppear = 400

    if (scrollY > scrolledPixelsBeforeBtnAppear){
        btnToTop.style.display = 'inline'
    } else {
        btnToTop.style.display = 'none'
    }
}

let gotoTop = () => {
    window.scrollTo(0, 0)
}

let toggleMenu = () => {
    let menu = document.getElementById('col-nav')
    if (menu.style.display == 'none' || menu.style.display == ''){
        menu.style.display = 'flex'
    } else {
        menu.style.display = 'none'
    }
}

let messageMe = () => document.getElementById('messageBox').style.display = 'block'

let closeMessageBox = () => document.getElementById('messageBox').style.display = 'none'

// let formEvent = (e) => {
//     e.preventDefault()

//     e.defaultPrevented()
// }

// let interceptForm = () => {
//     document.getElementById('contactMeForm').addEventListener("submit", (e) => {
        
//         console.log(e)
//     })
// }

let scrollSubscribers = () => {
    elasticNav()
    backToTop()
}
window.onscroll = scrollSubscribers
//interceptForm()