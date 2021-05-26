const { Component, useState, useEffect, useRef, useReducer } = wp.element;
const { apiFetch } = wp;
const { addQueryArgs } = wp.url;
//import PropTypes from 'prop-types';

export function useRbFetch(path, props){
    props = props ? props : {};
    props = {
        queryArgs: null,
        data: null,
        method: 'get',
        updateOnArgsChange: true,
        filterData: null,
        onThen: null,
        onCatch: null,
        needsUpdateCheck: null,
        ...props,
    };

    const isMountFetch = useRef(true);
    const [state, setState] = useReducer(
        (prevState, action) => { /*console.log('state change');*/ return {...prevState, ...action}; },
        {
            response: null,
            responseData: null,
            loading: false,
            error: false,
            shouldFetch: true,
        }
    );
    const prevProps = usePrevious(props);
    const prevPath = usePrevious(path);
    const triggerFetch = () => {
        setState({shouldFetch: true,})
    };

    useEffect(() => {
        // if(!props.updateOnArgsChange || (props.needsUpdateCheck && props.needsUpdateCheck()))
        //     return;
        if( !isMountFetch.current && ( !props.updateOnArgsChange ||
            ( (prevPath == path) && (JSON.stringify(prevProps) == JSON.stringify(props)) ) )
        )
            return;

        if( !path )
            return;
        isMountFetch.current = false;
        // if(!state.shouldFetch)
        //     return;
        setState({
            loading: true,
            shouldFetch: false,
        });
        path = props.queryArgs ? addQueryArgs(path, props.queryArgs) : path;

        apiFetch({
            data: props.data,
            method: props.method,
            path,
            parse: false
        })
        .then((response) => {
            response.json().then((responseData) => {
                //console.log(state);
                setState({response, responseData, loading: false, error: false});
                if(props.onThen)
                    props.onThen({response, responseData});
            });
        })
        .catch((response) => {
            setState({response, loading: false, error: true});
            if(props.onCatch)
                props.onCatch({response});
        });
    });

    return {
        response: state.response,
        responseData: state.responseData,
        status: {
            loading: state.loading,
            error: state.error,
        },
        triggerFetch: triggerFetch,
    };
}

function usePrevious(value) {
  // The ref object is a generic container whose current property is mutable ...
  // ... and can hold any value, similar to an instance property on a class
  const ref = useRef();

  // Store current value in ref
  useEffect(() => {
    ref.current = value;
  }, [value]); // Only re-run if value changes

  // Return previous value (happens before update in useEffect above)
  return ref.current;
}

export function rbDoFetch(restPath, args){
    if(!restPath)
        return false;
    const defaultArgs = {
        parse: false,
        queryArgs: null,
        data: null,
        method: 'get',
    }
    args = args ? Object.assign({}, defaultArgs, args) : defaultArgs;
    restPath = args.queryArgs ? addQueryArgs(restPath, args.queryArgs) : restPath;

    return apiFetch({
        path: restPath,
        ...args,
    });
}

/**
*   @param {string}    fetchDataPropIdentifier
*   Identifier used to distinguish the data send from the HOC to the WrappedComponent, from other HOCs that my used the same default prop name
*/
export default function RBFetchHOC(fetchDataPropIdentifier){
    const fetchDataPropName = typeof fetchDataPropIdentifier === 'string' ? fetchDataPropIdentifier : 'fetchData';
    return (WrappedComponent) => {
        return class RBFetchHOCClass extends Component{
            static defaultProps = {
                queryArgs: {},
                fetchOnMount: true,
                abortPreviousRequestOnNew: true,
                parse: false,
                fetchMethod: 'get',
                requestData: null,
                restPath: '',
                needsUpdateCheck: null,
                onFetchSuccess: null,
                //Allows to mutate the sent through the fetchData prop
                fetchDataFilter: null,
            };

            constructor(props){
                super(props);

                this.initialState = {
                    data: null,
                    fetchOngoing: false,
                    fetchError: false,
                };

                this.state = this.initialState;
            }

            componentDidMount() {
                if(this.props.fetchOnMount)
                    this.fetchData();
            }

            componentDidUpdate(prevProps, prevState) {
                if(this.props.needsUpdateCheck && this.props.needsUpdateCheck(prevProps, prevState)){
                    //console.log('needsUpdate: true => updating');
                    this.abortLastRequest();
                    this.fetchData();
                }
            }

            abortLastRequest(){
                this.requests[Object.keys(this.requests).length - 1].aborted = true;
            }

            isAborted(requestID){
                return this.requests[requestID] && this.requests[requestID].aborted;
            }

            storeNewRequest(request){
                this.requests = this.requests ? this.requests : {};
                var requestID = Object.keys(this.requests).length;
                this.requests[requestID] = {
                    request: request,
                    aborted: false,
                    id: requestID
                };
                return this.requests[requestID];
            }

            fetchData(){
                this.setState({ fetchOngoing: true });
                if(!this.props.restPath){
                    this.setState({ fetchOngoing: false, });
                    return false;
                }

                var request = rbDoFetch(this.props.restPath, {
                    queryArgs: this.props.queryArgs,
                    method: this.props.fetchMethod,
                    data: this.props.requestData,
                    parse: this.props.parse,
                });
                var requestData = this.storeNewRequest(request);

                request.then(response => {
                    if(this.props.abortPreviousRequestOnNew && this.isAborted(requestData.id))
                        return false;
                    response.json().then((data) => {
                        this.setState({
                            data: data,
                            fetchOngoing: false,
                            fetchError: false,
                        }, () => {
                            if(this.props.onFetchSuccess){
                                this.props.onFetchSuccess(response, data);
                            }
                        });
                    });
                })
                .catch(response => {
                    if(this.props.abortPreviousRequestOnNew && this.isAborted(requestData.id))
                        return false;
                    this.setState({
                        fetchOngoing: false,
                        fetchError: {
                            response: response,
                        },
                    });
                });
            }

            getPassThoughProps(){
                let passThroughProps = Object.assign({}, this.props);
                for(let hocPropName in RBFetchHOCClass.defaultProps){
                    if(passThroughProps.hasOwnProperty(hocPropName))
                        delete passThroughProps[hocPropName];
                }
                return passThroughProps;
            }

            getFetchData(){
                let fetchData = {};
                fetchData[fetchDataPropName] = {
                    data: this.state.data,
                    fetchStatus: {
                        ongoing: this.state.fetchOngoing,
                        error: this.state.fetchError,
                    },
                    doFetch: () => this.fetchData(),
                };
                if(this.props.fetchDataFilter)
                    fetchData[fetchDataPropName] = this.props.fetchDataFilter(fetchData[fetchDataPropName]);
                return fetchData;
            }

            render(){
                let fetchData = this.getFetchData();
                const passThroughProps = this.getPassThoughProps();
                return (
                    <WrappedComponent
                        {...passThroughProps}
                        {...fetchData}
                    >
                    </WrappedComponent>
                );
            }
        }
    };
}
