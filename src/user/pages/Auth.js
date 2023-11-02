import React, { useState, useContext } from "react";

import './Auth.css';
import Input from "../../shared/components/FormElements/Input";
import { 
    VALIDATOR_MINLENGTH, 
    VALIDATOR_EMAIL,
    VALIDATOR_REQUIRE 
} from "../../shared/util/validators";
import Button from '../../shared/components/FormElements/Button'
import { useForm } from "../../shared/hooks/form-hook";
import Card from "../../shared/components/UIElements/Card";
import { AuthContext } from "../../shared/context/auth-context";

const Auth = () => {

    const auth = useContext(AuthContext);

    const [ isLoginMode, setIsLoginMode ] = useState(true);

    const [formState, inputHandler, setFormData] = useForm(

        {

            email: {
                value: '',
                isValid: false
            },
            password: {
                value: '',
                isValid: false
            }

        }, false);

    const authSubmitHandler = event => {

        event.preventDefault();
        console.log(formState.inputs);
        auth.login();

    };

    const switchModeHandler = () => {

        if (!isLoginMode) {

            setFormData({
                ...formState.inputs,
                name: undefined
            }, formState.inputs.email.isValid && formState.inputs.password.isValid);

        } else {

            setFormData({
                ...formState.inputs,
                name: {
                    value: '',
                    isValid: false
                }
            }, false);

        }

        setIsLoginMode(prevMode => !prevMode);

    }

    return (
        <Card className='authentication'>
            <form onSubmit={authSubmitHandler}>

                <h2>Login Required</h2><hr/>

                {!isLoginMode &&
                
                <Input 
                
                    id="name"
                    element="input"
                    type="text"
                    label="Name"
                    validators={[VALIDATOR_REQUIRE()]}
                    errorText="Please enter a name."
                    onInput={inputHandler} 

                />}

                <Input

                    id="email"
                    element="input"
                    type="text"
                    label="E-Mail"
                    validators={[VALIDATOR_EMAIL()]}
                    errorText="Please enter a valid email address."
                    onInput={inputHandler}

                />

                <Input

                    id="password"
                    element="input"
                    type="password"
                    label="Password"
                    validators={[VALIDATOR_MINLENGTH(10)]}
                    errorText="Please enter a valid password, at least 10 characters."
                    onInput={inputHandler}

                />

                <Button 
                type="submit" 
                disabled={!formState.isValid}
                >
                    {isLoginMode ? 'LOGIN' : 'SIGNUP'}
                </Button>

            </form>

            <Button inverse onClick={switchModeHandler}>                
                SWITCH TO {isLoginMode ? 'LOGIN' : 'SIGNUP'}                
            </Button>

        </Card>

    );

};

export default Auth;