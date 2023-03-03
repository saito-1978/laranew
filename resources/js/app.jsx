import './bootstrap';

import React from "react";

import ReactDOM from "react-dom/client";

import Alpine from 'alpinejs';

import Counter from './components/Counter';

window.Alpine = Alpine;

Alpine.start();

function App() {
    return (<>
        <h1>React testpege</h1>
        <Counter /> 
        </>);
}

const root = ReactDOM.createRoot(document.getElementById("app"));
root.render(<App />);


