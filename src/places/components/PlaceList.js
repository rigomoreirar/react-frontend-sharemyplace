import React from "react";

import './PlaceList.css';
import Card from '../../shared/components/UIElements/Card';
import PlaceItem from "./PlaceItem";
import Button from "../../shared/components/FormElements/Button";

const PlaceList = props => {

    if (props.item.length === 0){
        return (
            <div className="place-list center">
                <Card>
                    <h2>No places Found. Maybe create one?</h2>
                    <Button to='/places/new'>Share Place</Button>
                </Card>
            </div>
        );
    }

    return (
        <ul className="place-list">
            {props.item.map(place => (
                <PlaceItem 
                    key={place.id} 
                    id={place.id} 
                    image={place.imageUrl} 
                    title={place.title} 
                    address={place.address} 
                    creator={place.creator} 
                    coordinates={place.location}
                    description={place.description}
                />
            ))}
        </ul>
    );
};

export default PlaceList;