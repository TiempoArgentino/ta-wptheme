import './required-taxonomies.js';
import './etiquetador.js';

import { render, unmountComponentAtNode } from "react-dom";

MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
const hooks = [];

/**
*   Returns node hook info if matches any hook selector
*/
function getNodeComponentHook(node){
    return node && node.matches ? hooks.filter( hook => node.matches( hook.selector ) )[0] : null;
}

/**
*   Render the component inside a container that goes into node, to not lose
*   the node reference in DOM
*/
function renderInside({ component, node }){
    const containerNode = document.createElement('div');
    node.innerHTML = '';
    node.appendChild(containerNode);
    node.componentContainer = containerNode;
    render(component, containerNode);
}

/**
*   Listens to addition or removal of nodes that matches the querySelector and
*   mount/unmount the desired component in them as needed.
*/
function hookComponentToNode(props){
    const { component, querySelector } = props;
    hooks.push( props );

    // Current Elements
    document.querySelectorAll(querySelector).forEach((node, i) => {
        renderInside({ component, node });
    });
}

/**
*   Observe elements and add/remove components as needed
*/
const obs = new MutationObserver(function(mutations, observer) {
    if(!hooks || !hooks.length)
        return;

    // look through all mutations that just occured
    for(var i=0; i<mutations.length; ++i) {
        // look through all added nodes of this mutation
        for(let j=0; j<mutations[i].addedNodes.length; ++j) {
            const mutationNode = mutations[i].addedNodes[j];
            const hook = getNodeComponentHook( mutationNode );
            console.log(hook);
            if( hook  ){
                console.log("New Element");
                renderInside({
                    component: hook.component,
                    node: mutationNode
                });
            }
        }

        // look through all removed nodes of this mutation
        for(let j=0; j<mutations[i].removedNodes.length; ++j) {
            const mutationNode = mutations[i].removedNodes[j];
            const hook = getNodeComponentHook( mutationNode );
            const componentContainer = mutationNode.componentContainer;
            if( componentContainer ){
                console.log('Element removed', unmountComponentAtNode(componentContainer));
            }
        }
    }
});

obs.observe(document.body, {
  childList: true,
  subtree: true,
});


/************
*   TEST
************/
// hookComponentToNode({
//     component: <div className="ta_article_images_column">Test</div>,
//     querySelector: `.ta_article_images_column`,
// });
