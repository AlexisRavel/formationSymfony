import React from "react";
import Header from "./Header";

class App extends React.Component {
    constructor(props) {
        super()
        this.state = { 
            user: props.user
        };
    }

    render() {
        if(this.state.user != null) {
            return (
                <div>
                    <Header user={this.state.user}/>
                </div>
            );
        } else {
            return (
                <header>
                    <a href="/login">Se connecter</a>
                </header>
            );
        }
    }
}

export default App