# Multisite SuperList

> Replace that useless WordPress Multisite site list with something far better!

- If you manage lots of sites in a Multisite network, you'll know how frustrating using the Sites List can be. You can't scroll, so if you have more than 30 sites, you are forced to go to the Sites screen. The flyout submenus can be bit hard to navigate, and there are options in there that are kinda pointless (comments???).

- That said, the Sites List has a lot of potential, and I wanted to improve upon it. The ideas I had were:
- It should have useful links without submenus.
- It should have a search feature like the very cool plugin [My Sites Search](https://github.com/trepmal/my-sites-search) by [Kailey Lampert](https://github.com/trepmal)

[![Demonstration of Multisite SuperList in action](multisite-superlist.gif)]()

- This is my first project I'd like to open source. So PLEASE feel free to contribute. I'd like to eventually see this, or an improved upon version of this, in Core.

---

## Installation

- This is a WordPress plugin that will only work in a Multisite environment (if you don't know what that means, you don't have it).

### Download the zip file

- Download the zip file.
- In WordPress, from the Network Admin:
- Install new plugin.
- Click on upload file.
- Select the zip file you just downloaded.
- Network Activate the plugin.

### Setup

- There is no setup. It is plug and play.

## Changelog

All notable changes to this project will be documented in this file.


## [2.1.0]

### Changed

-Renamed Multisite SuperList from Multisite Sites List.

## [2.0.1]

### Changed

-Removed Build folder from the Gitignore file.

## [2.0]

### Changed

-Refactored over to React & REST API.

## [1.10] -

### Changed

-Initial commit.

---

## TODO

-Add search functionality.
-Add pagination to query.
-Add infinite scroll to reduce load time.
-Add Mapped Domains.
-Add WP Ultimo functionailty for those running WAAS type setups.

## Contact

- Create issues here, or hit me up on Twitter [@williambay](https://twitter.com/williambay)
