const siteList = () => {
    const networkUrl = msl_localize_scripts.networkUrl
    const networkAdmin = networkUrl + "wp-admin/network"

    fetch(networkUrl + "/wp-json/msl/v1/sites")
        .then(function (response) {
            if (response.status !== 200) {
                console.log(
                    "Looks like there was a problem. Status Code: " +
                        response.status
                )
                return
            }

            // Examine the text in the response
            response.json().then(function (data) {
                sessionStorage.setItem("sitesList", JSON.stringify(data))
            })
        })
        .catch(function (err) {
            console.log("Fetch Error :-S", err)
        })

    const adminListUl = document.querySelector("#wp-admin-bar-root-default")
    const originalList = document.querySelector("#wp-admin-bar-my-sites")
    const originalSites = originalList.querySelector(".ab-sub-wrapper")

    // Remove the original list
    originalSites.remove()

    // Add the new list item.
    const newList = document.createElement("li")
    originalList.appendChild(newList)

    // Add a new UL to My Sites item
    const newListUl = document.createElement("ul")
    newListUl.className = "sites-list"
    newList.appendChild(newListUl)

    const network = document.createElement("li")
    network.className = "site-network"

    network.innerHTML =
        "<div>" +
        '<a id="network" href="' +
        networkAdmin +
        '">Network Admin</a>' +
        '<a style="font-size:80%;" href="' +
        networkAdmin +
        '/sites.php">Sites</a>' +
        '<a style="font-size:80%;" href="' +
        networkAdmin +
        '/users.php">Users</a>' +
        '<a style="font-size:80%;" href="' +
        networkAdmin +
        '/themes.php">Themes</a>' +
        '<a style="font-size:80%;" href="' +
        networkAdmin +
        '/plugins.php">Plugins</a>' +
        '<a style="font-size:80%;" href="' +
        networkAdmin +
        '/settings.php">Settings</a>' +
        "</div>"
    newListUl.appendChild(network)

    /**
     * Search bar
     */

    const search = document.createElement("li")
    search.className = "search"
    search.innerHTML =
        '<div><input type="search" id="sites-search" name="sites-search" onkeyup="sitesFilter()" placeholder="Search"></div>'
    newListUl.appendChild(search)

    var object = JSON.parse(sessionStorage.getItem("sitesList"))
    var sites = Object.keys(object).map(function (key) {
        return [Number(key), object[key]]
    })

    for (i = 0; i < sites.length; i++) {
        const listItem = document.createElement("li")
        listItem.className = "site"
        listItem.innerHTML =
            '<div><div class="ico"><img src="'+sites[i][1].favicon+'" /></div>' +
            '<a class="site" href="' +
            sites[i][1].siteurl +
            '/wp-admin">' +
            sites[i][1].blogname +
            "</a>" +
            '<a class="dashboard" style="font-size:80%;" href="' +
            sites[i][1].siteurl +
            '/wp-admin">Dashboard</a>' +
            '<a class="visit" style="font-size:80%;" href="' +
            sites[i][1].siteurl +
            '">Visit Site</a></div>'

        newListUl.appendChild(listItem)
    }
}
siteList()

function sitesFilter() {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue
    input = document.querySelector("#sites-search")
    filter = input.value.toUpperCase()
    ul = document.querySelector(".sites-list")
    li = ul.querySelectorAll("li.site")
    li = Array.from(li)
    console.log(li)
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].querySelector("a")
        txtValue = a.innerText
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = ""
        } else {
            li[i].style.display = "none"
        }
    }
}
