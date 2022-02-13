import React from 'react';
import ReactDOM from 'react-dom';
import './index.scss';
import Sitelist from './Sitelist';

const mySites = document.querySelector('#wp-admin-bar-my-sites .ab-sub-wrapper');

ReactDOM.render(
  <React.StrictMode>
    <Sitelist />
  </React.StrictMode>, mySites
);
