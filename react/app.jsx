import React from 'react';

import PropTypes from 'prop-types';

import Request from 'axios';

import { applyMiddleware, createStore } from 'redux';

import { logger } from 'redux-logger';

import thunk from 'redux-thunk';

import {
    render,
} from 'react-dom';

import {
    BrowserRouter,
    Route,
    Switch
} from 'react-router-dom';

class Product extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            productName: '',
            productValue: 0
        };

        Request.get('/get_product/' + props.product).then(response => {
            let result = response.data;
            this.setState({productName:result.productName, productValue:result.productValue});
        });
    }
    render() {
        return (
            <div className="shopping-list">
                <h1>Information about product {this.props.product}</h1>
                <h2>{this.props.productId}</h2>
                <ul>
                    <li>{this.state.productName}</li>
                    <li>{this.state.productValue}</li>
                </ul>
            </div>
        );
    }
}

Product.propTypes = {
    product: PropTypes.number,
    productId: PropTypes.number
};

const NewEntity = (props) => {
    return (
        <div></div>
    )
}


const Homepage = () => {
    return (
        <div>HEllo World</div>
    );
};

const reducer = function(state, action) {
    if (action.type === "INC") {
        return state+action.payload;
    }
    return state;
};

const middleware = applyMiddleware(thunk, logger);
const store = createStore(reducer, middleware);

store.subscribe(() => {
   console.log("store changed", store.getState());
});

class ProductPage extends React.Component
{
    constructor(props) {
        super(props);

        this.state = {
            prodId: '',
            newProd: 'ddd'
        };
    }

    changed(event) {
        this.setState({
            prodId: event.target.value
        });
        store.dispatch({type: "INC", payload: 1});
    }

    render() {
        return (
            <div>
                <Product product={this.props.match.params.productId} productId={this.state.prodId}/>
                <NewEntity newproduct={this.state.newProd}/>
                <h1>Hello h1</h1>
                <h2>Hello h2</h2>
                <h3>Hello h3</h3>
                <input type="text" onInput={this.changed.bind(this)}/>
            </div>
        );
    }
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
                <Route path="/product/:productId" component={ProductPage}/>
                <Route path="*" component={Homepage404}/>
            </Switch>
        </BrowserRouter>
), document.getElementById('app'));
