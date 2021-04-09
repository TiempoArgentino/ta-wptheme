import { render, unmountComponentAtNode } from "react-dom";
var $ = require( "jquery" );

MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
const hooks = [];

/**
*   Runs a filter on every node in a tree and runs a callback for every match
*   @param {Node} node                                                          The first node in the tree
*   @param {Node} cb                                                            Callback to run on matched nodes
*   @param {Node} filter                                                        Callback that indicates wheter a node is a match or not
*   @param {Node} doMatchChilds                                                 If the filter should run on the children of matched nodes
*/
function doForEveryMatch(props){
    const { node, cb, filter, doMatchChilds } = props;
    const filterResult = filter(node);

    if(filterResult){
        cb(node, filterResult);
    }

    if( node.children && ( !filterResult || doMatchChilds ) ){
        for (let childNode of node.children) {
            doForEveryMatch({
                ...props,
                node: childNode,
            })
        }
    }
}

/**
*   Returns node hook info if matches any hook selector
*/
function getNodeComponentHook(node){
    return node && node.matches ? hooks.filter( hook => node.matches( hook.querySelector ) )[0] : null;
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
            // console.log('Added node', mutations[i], mutationNode);

            doForEveryMatch({
                node: mutationNode,
                doMatchChilds: false,
                filter: (node) => {
                    return getNodeComponentHook( node );
                },
                cb: (node, hook) => {
                    console.log("Component mounted");
                    renderInside({
                        component: hook.component,
                        node,
                    });
                },
            });
        }

        // look through all removed nodes of this mutation
        for(let j=0; j<mutations[i].removedNodes.length; ++j) {
            const mutationNode = mutations[i].removedNodes[j];

            doForEveryMatch({
                node: mutationNode,
                doMatchChilds: false,
                filter: (node) => {
                    return node.componentContainer;
                },
                cb: (node, componentContainer) => {
                    console.log("Component unmounted");
                    unmountComponentAtNode(componentContainer)
                },
            });
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

// Test control en attachment data
// hookComponentToNode({
//     component: <div className="ta_article_images_column">Test</div>,
//     querySelector: `.compat-field-ta_attachment_author`,
// });
