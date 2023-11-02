import React from "react";
import UsersList from "../components/UsersList/UsersList";

const Users = () => {
const USERS = [
    {
        id: 'u1',
        name: 'Rigoberto Moreira',
        image: 'https://images.pexels.com/photos/18254681/pexels-photo-18254681.jpeg',
        places: 3
    },
];

    return(
        <UsersList items={USERS}/>
    );
};

export default Users;