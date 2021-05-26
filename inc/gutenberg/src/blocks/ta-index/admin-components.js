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

    if( node.children && ( !filterResult && doMatchChilds ) ){
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
function renderInside({ component, node, removeOldHtml }){
    const containerNode = document.createElement('div');
    if(removeOldHtml)
        node.innerHTML = '';
    node.appendChild(containerNode);
    node.componentContainer = containerNode;
    render(component, containerNode);
}

function renderHook({ node, hook }){
    // console.log('renderHook', hook);
    renderInside({
        component: hook.component({
            node: node,
            nodeBeforeMount: node.cloneNode( true ),
        }),
        node: node,
        removeOldHtml: hook.removeOldHtml,
    });
}

/**
*   Listens to addition or removal of nodes that matches the querySelector and
*   mount/unmount the desired component in them as needed.
*/
export function hookComponentToNode(props){
    const { component, querySelector, removeOldHtml } = props;
    const hook = props;
    hooks.push( hook );
    // Current Elements
    document.querySelectorAll(querySelector).forEach((node, i) => {
        renderHook({ node, hook });
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
            // console.log('mutationNode', mutations[i], mutationNode);

            doForEveryMatch({
                node: mutationNode,
                doMatchChilds: true,
                filter: (node) => {
                    return getNodeComponentHook( node );
                },
                cb: (node, hook) => {
                    // console.log("Component mounted", mounted, node, hook);
                    renderHook({ node, hook });
                },
            });
        }

        // look through all removed nodes of this mutation
        for(let j=0; j<mutations[i].removedNodes.length; ++j) {
            const mutationNode = mutations[i].removedNodes[j];

            doForEveryMatch({
                node: mutationNode,
                doMatchChilds: true,
                filter: (node) => {
                    return node.componentContainer;
                },
                cb: (node, componentContainer) => {
                    // console.log("Component unmounted");
                    unmountComponentAtNode(componentContainer)
                    componentContainer.parentNode.removeChild(componentContainer);
                },
            });
        }
    }

    // console.log('MutationObserver end');
});

obs.observe(document.body, {
  childList: true,
  subtree: true,
});


/************
*   TEST
************/
// hookComponentToNode({
//     component: () => <div className="ta_article_images_columntest">Test</div>,
//     querySelector: `.ta_article_images_column`,
// });

// Test control en attachment data
// hookComponentToNode({
//     Item: <div className="ta_article_images_column">Test</div>,
//     querySelector: `.compat-field-ta_attachment_author`,
// });
