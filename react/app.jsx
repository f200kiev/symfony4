import React from 'react';

import {
    render
} from 'react-dom';

import {
    BrowserRouter,
    Route,
    Switch
} from 'react-router-dom';

const Homepage = () => {
    return (
        <div>HEllo World</div>
    );
};

const ProductPage = () => {
    return (
        <div>Hello  ssss</div>
    );
};

const Homepage404 = () => {
    return (
      404
    );
};

render((
        <BrowserRouter>
            <Switch>
                <Route exact path="/" component={Homepage}/>
                <Route path="/product/*" component={ProductPage}/>
                <Route path="*" component={Homepage404}/>
            </Switch>
        </BrowserRouter>
), document.getElementById('app'));
