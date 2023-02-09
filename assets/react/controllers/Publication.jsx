import React from "react";

class Publication extends React.Component {
    constructor(props) {
        super();
        this.state = {
            post: props.post
        }
    }

    render() {
        return(
            <div className="post">
                <h3>{this.state.post.titre}</h3>
                <p>{this.state.post.resume}</p>
                <a href={'/publication/' + this.state.post.id}>Plus de détails</a>
            </div>
        );
    }
}

export default Publication;