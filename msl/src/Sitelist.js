/* eslint-disable no-undef */
import React from 'react';
import './Sitelist.scss';
import { Fragment } from 'react/cjs/react.production.min';
import { useState, useEffect, useCallback } from "react";
import axios from "axios";

const mslSiteInfo = msl_site_info
const networkURL =  `${mslSiteInfo.site_url}/wp-admin/network/`
const sitesEndpoint = `${mslSiteInfo.site_url}/wp-json/msl/v1/sites`
const mySites = document.querySelector('#wp-admin-bar-my-sites a');
const search = document.querySelector("#search")
const newSearchItems = []
// TODO Pagination const TOTAL_PAGES = 30;

// TODO The loading spinner.
// const Loader = () => {
//   return (
//       <div >
//           <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
//               <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
//               <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
//           </svg>
//       </div>
//   )
// }


// Outputs the site list.
function Sitelist () {

  const [sites, setSites]                 = React.useState([]);
  const [searchInput, setSearchInput]     = useState('');
  const [filteredSites, setFilteredSites] = useState([]);

  const [isLoading, setIsLoading] = React.useState(false);
  const [hasMore, setHasMore]     = React.useState(true);
  const [pages, setPages]         = React.useState(1);


useEffect(() => {
  axios.get(sitesEndpoint)
      .then((response) => {
        setSites(response.data);
      })
      .catch(function (error) {
      console.log(error);
      })
}, [])

const searchItems = (searchValue) => {
  setSearchInput(searchValue)
  if ( "" !== searchInput){
    const filteredData = sites.filter((site) => {
        return Object.values(site.name).join('').toLowerCase().includes(searchInput.toLowerCase())
      })
      setFilteredSites(filteredData)
  } 
}

  return (
    <Fragment>
      <div id="site-list">
        <div id="network-admin">
          <a href={networkURL + "sites.php"} style={{fontWeight:"bold"}}>Network Admin</a>
          <ul>
            <li><a href={networkURL}>Dashboard</a></li>
            <li><a href={networkURL + "sites.php"}>Sites</a></li>
            <li><a href={networkURL + "users.php"}>Users</a></li>
            <li><a href={networkURL + "themes.php"}>Themes</a></li>
            <li><a href={networkURL + "plugins.php"}>Plugins</a></li>
            <li><a href={networkURL + "settings.php"}>Settings</a></li>
          </ul>
          <input id="search" type="text" placeholder="Search for your site" onChange={ (e) => searchItems(e.target.value)} />
        </div>

        <ul id="sites">
          {searchInput.length > 1 ? (
            filteredSites.map( 
              site => { 
              return (
                  <li key={site.site_id} class="site">
                  <img src={site.favicon} id="msl-favicon" alt=""/> 
                  <a href={site.url + '/'} id="msl-sitename" >{site.name}</a>
                  <a href={site.url + '/wp-admin/'}>Dashboard</a>
                  <a href={site.url + '/'}>Visit Site</a>
                  <a href={site.url + '/wp-admin/post-new.php'}>New Post</a>
                  <a href={site.url + '/wp-admin/post-new.php?post_type=page'}>New Page</a>
                  <a href={site.url + '/wp-admin/plugins.php'}>Plugins</a>
                </li> 
              )
            })) : (
            sites.map( 
              site => {
                return (
                  <li key={site.site_id} class="site">
                    <img src={site.favicon} id="msl-favicon" alt=""/> 
                    <a href={site.url + '/'} id="msl-sitename" >{site.name}</a>
                    <a href={site.url + '/wp-admin/'}>Dashboard</a>
                    <a href={site.url + '/'}>Visit Site</a>
                    <a href={site.url + '/wp-admin/post-new.php'}>New Post</a>
                    <a href={site.url + '/wp-admin/post-new.php?post_type=page'}>New Page</a>
                    <a href={site.url + '/wp-admin/plugins.php'}>Plugins</a>
                  </li>  
                )
              }
            ))}
        </ul>
        {/* TODO {isLoading && <Loader />} */}
      </div>
    </Fragment>
  );
}

export default Sitelist;
