function confirmDelete(prodname)
{
    let event = window.event
    event.preventDefault()
    const modal = document.querySelector("#modal")
    modal.style.display = "block"

    let url = event.target.getAttribute("href") 
    
    modal.querySelector(".modal-actions__confirm").setAttribute("href", url)
    modal.querySelector(".modal__name").innerText = prodname
    modal.querySelector(".modal-actions__cancel").addEventListener("click", () => {
        modal.style.display = "none"
    })
}