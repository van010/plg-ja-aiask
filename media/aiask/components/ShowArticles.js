import React, {useEffect, useState} from "react";
// import axios from "axios";


const ShowArticles = () => {
    const [article, setArticles] = useState([]);
    const joomlaApi = buildApi({option: 'com_ajax', plugin: 'jaaiask', task: 'fetch_article'});
    const fakeApi = 'https://jsonplaceholder.typicode.com/todos/1';

    useEffect(() => {
        const fetchArticles = async () => {
            try{
                const response = await fetch(joomlaApi)
                    .then(res => {
                        return res.json();
                    })
                    .then(json => {
                        console.log(json);
                    });
                console.log(response);
            }catch(error){
                console.error('Error fetching articles:', error);
            }
        };

        fetchArticles();
    }, []);
    return (
        <div>
            <h2>Articles Fetching...</h2>
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    );
}

const buildApi = ({option = null, plugin= null, task = null, format = 'json'} = {}) => {
    const urlBase = 'http://php82.dev.co/j5-blank/';
    const urlParams = {
        option: option, //, 'com_ajax',
        plugin: plugin, // 'jaaiask',
        format: format,
        aitask: task,  // 'fetch_article'
        // token: 'u2bff',
    };
    const paramString = new URLSearchParams(urlParams).toString().replace(/%2C/g, ',');
    const queryString = `${urlBase}index.php?${paramString}`;
    return queryString;
};

export default ShowArticles;