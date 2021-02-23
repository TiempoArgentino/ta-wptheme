const { Component, useState, useEffect } = wp.element;

import RBFetchHOC, {useRbFetch} from '../rb-fetch-hoc/rb-fetch-hoc.js';

export function useTermsFetch(args = {}){
    const {
        //Arguments for the terms query
        termsQueryArgs = {},
        //Arguments for the fetch hook
        fetchArgs = {},
    } = args;

    //Terms query
    const termsQuery = {
        //only_include: true,
        //hide_empty: true,// red
        ...termsQueryArgs,
    };

    //Fetch Args
    const finalFetchArgs = {
        updateOnArgsChange: false,
        ...fetchArgs,
    };

    //Terms Fetch
    const {response, responseData: terms, status} = useRbFetch('/rb/v1/terms', {
        ...finalFetchArgs,
        queryArgs: termsQuery,
    });
    const totalPages =  response && response.headers ? parseInt(response.headers.get( 'X-WP-TotalPages' )) : 0;

    return {
        terms,
        totalPages: totalPages,
        status,
        response,
    };
}

export default function RBTermsFetch(){
    return (HocComponent) => {
        return class extends Component{
            static defaultProps = {
                updateTermsOnArgsChange: true,
                termsFetchArgs: {
                    taxonomy: 'post_tag',
                },
            }

            constructor(props){
                super(props);

                this.initialState = {
                    terms: [],
                }

                this.state = this.initialState;
                this.RBFetch = RBFetchHOC('termsFetchData')(HocComponent);
            }

            checkNeedsUpdate(prevProps, prevState){
                if(this.props.updateTermsOnArgsChange && this.restArgsChanged(prevProps)){
                    //console.log('Terms fetch arguments changed => needsUpdate');
                    return true;
                }
                return false;
            }

            restArgsChanged(prevProps){
                const newArgs = this.props.termsFetchArgs;
                const prevArgs = prevProps.termsFetchArgs;
                if((newArgs && !prevArgs) || (!newArgs && prevArgs))
                    return true;
                if(newArgs == prevArgs)
                    return false;

                for (let argKey in newArgs){
                   if(newArgs.hasOwnProperty(argKey)){
                       if(!prevArgs.hasOwnProperty(argKey) || (newArgs[argKey] != prevArgs[argKey]))
                           return true;
                   }
                }
                return false;
            }

            onFetchSuccess(response, data){
                //console.log('FETCH SUCCESS');
                this.setState({
                    totalPages: response.headers ? parseInt(response.headers.get( 'X-WP-TotalPages' )) : 0,
                    terms: data,
                }, () => {
                    if(this.props.onFetchSuccess)
                        this.props.onFetchSuccess(response, data);
                });
            }

            fetchDataFilter(data){
                return {
                    ...data,
                    terms: this.state.terms,
                    totalPages: this.state.totalPages,
                };
            }

            render(){
                //const {...passThroughProps} = this.props;
                return(
                    <this.RBFetch
                        {...this.props}
                        queryArgs={this.props.termsFetchArgs}
                        restPath='/rb/v1/terms'
                        needsUpdateCheck={(prevProps, prevState) => this.checkNeedsUpdate(prevProps, prevState)}
                        onFetchSuccess={(response, data) => this.onFetchSuccess(response, data)}
                        fetchDataFilter={(data) => this.fetchDataFilter(data)}
                    />
                );
            }
        }
    };
}
