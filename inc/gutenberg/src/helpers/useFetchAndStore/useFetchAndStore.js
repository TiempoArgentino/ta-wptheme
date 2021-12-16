import React, { useState, useEffect, useRef } from "react";
const { apiFetch } = wp;

export const useFetchAndStore = (props) => {
    const {values, fetchData, onChange} = props;
    const [storedData, setStoredData] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const needsUpdateRef = useRef(false);
    const dataBeingFetchedRef = useRef(false);

    const getStoredData = ({ value, index }) => {
        // console.log('Searching', value);
        return storedData.find( data => data.originalValue == value );
    };

    const generateStoredData = () => {
        const newStoredData = [];

        if(values.length != storedData.length)
            needsUpdateRef.current = true;

        if(values && values.length){
            for (let index = 0; index < values.length; index++) {
                const value = values[index];
                const data = getStoredData({ value: value, index, });

                if( storedData[index] && storedData[index].originalValue != value )
                    needsUpdateRef.current = true;

                if(data){
                    newStoredData.push(data);
                }
                else{
                    newStoredData.push({
                        data: null,
                        loading: true,
                        originalValue: value,
                    });
                }
            }
        }

        // setLoading(false);
        return newStoredData;
    };

    useEffect( () => {
        ( async () => {
            if(storedData){
                const mutatedStoredData = [...storedData];
                let needsUpdate = false;
                for(let i = 0; i < storedData.length; i++){
                    const {data, loading, fetchPromise, fetchFilter} = storedData[i];
                    if(loading){
                        dataBeingFetchedRef.current = true;
                        mutatedStoredData[i].data = fetchPromise ? await fetchPromise() : await fetchData({ value: mutatedStoredData[i].originalValue });
                        dataBeingFetchedRef.current = false;
                        mutatedStoredData[i].loading = false;
                        mutatedStoredData[i] = fetchFilter ? fetchFilter(mutatedStoredData[i]) : mutatedStoredData[i];
                        needsUpdate = true;
                        // setStoredData(mutatedStoredData);
                        // onChange ? onChange() : null;
                        // return;
                    }
                }
                if(needsUpdate){
                    // setTimeout( () => {
                        needsUpdateRef.current = true;
                        setStoredData(mutatedStoredData);
                        // onChange ? onChange() : null;
                    // }, 9999999);
                }
            }
        })()
        if(needsUpdateRef.current){
            onChange ? onChange({
                dataBeingFetched: dataBeingFetchedRef.current,
            }) : null;
            needsUpdateRef.current = false;
        }
    }, [storedData]);

    useEffect( () => {
        let newStoredData = generateStoredData();
        if(needsUpdateRef.current){
            setStoredData(newStoredData && newStoredData.length ? newStoredData : []);
        }
    }, [values]);


    return {
        storedData,
        setStoredData: (data) => {
            needsUpdateRef.current = true;
            setStoredData(data);
        },
        loading,
        error,
    }
}
