import React from "react";

class Header extends React.Component {
    constructor(props) {
        super();
        this.state = {
            user: props.user
        }
    }

    render() {
        if(this.state.user != null){
            return (
                <div>
                    <header>
                        <span>Actuellement connecté en tant que: {this.state.user.name}</span>
                        <a href="/logout">Se déconnecter</a>
                    </header>
                </div>
            );
        }else {
            return (
                <header>
                    <a href="/login">Se connecter</a>
                </header>
            );
        }
    }
}

export default Header;