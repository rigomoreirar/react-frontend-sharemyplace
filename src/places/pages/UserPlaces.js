import React from "react";
import { useParams } from 'react-router-dom';

import PlaceList from "../components/PlaceList";

const DUMMY_PLACES = [
    {
        id: 'p1',
        imageUrl: 'https://www.esbnyc.com/sites/default/files/2020-01/ESB%20Day.jpg',
        title: 'Empire State Building',
        address: '20 W 34th St., New York, NY 10001',
        creator: 'u1',
        location: {
            lat: 40.7484405,
            lng: -73.9882393
        },
        description: 'I was in the Empire State Building once, and it was AWSOME!!!!',
    },
    {
        id: 'p2',
        imageUrl: 'https://www.esbnyc.com/sites/default/files/2020-01/ESB%20Day.jpg',
        title: 'Empire 222',
        address: '20 W 34th St., New York, NY 10001',
        creator: 'u2',
        location: {
            lat: 40.7484405,
            lng: -73.9882393
        },
        description: 'I was in the Empire State Building once, and it was AWSOME!!!!',
    }
];

const UserPlaces = () => {

    //This is for getting the parameters through the url
    const userId = useParams().userId;

    const loadedPlaces = DUMMY_PLACES.filter(place => place.creator === userId);

    return (
        <PlaceList item={loadedPlaces}/>
    );
};

export default UserPlaces;