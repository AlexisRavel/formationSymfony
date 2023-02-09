import React from "react";

class App extends React.Component {
    constructor(props) {
        super()
        this.state = { user: props.user };
    }

    render() {
        if(this.state.user!=null) {
            return <div>{this.state.user.name}</div>;
        }
    }
}

export default App