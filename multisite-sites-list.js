function siteSearchBox() {
    const parentNode = document.querySelector(
        "#wp-admin-bar-my-sites .ab-sub-wrapper"
    )
    const referenceNode = document.querySelector("#wp-admin-bar-my-sites-list")
    const newNode = document.createElement("ul")
    newNode.id = "search"
    parentNode.insertBefore(newNode, referenceNode)

    const search = document.createElement("li")
    search.className = "search"
    search.innerHTML =
        '<div><input type="search" id="sites-search" name="sites-search" onkeyup="sitesFilter()" placeholder="Search"></div>'
    newNode.appendChild(search)
}
siteSearchBox()

function sitesFilter() {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue
    input = document.querySelector("#sites-search")
    filter = input.value.toUpperCase()
    ul = document.querySelector("#wp-admin-bar-my-sites-list")
    li = ul.querySelectorAll("li")

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0]
        txtValue = a.innerText
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = ""
        } else {
            li[i].style.display = "none"
        }
    }
}
sitesFilter()
