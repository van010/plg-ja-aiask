import React, {useEffect, useState} from "react";
import '../assets/ChatApp.css';


const ChatApp = () => {
    const [messages, setMessages] = useState([]);
    const [inputValue, setInputValue] = useState('');

    useEffect(() => {
        // auto reply from machine after a short delay
        const randomSentence = generateSentence(10);

        if (messages.length > 0 && messages[messages.length - 1].sender === 'User') {
            setTimeout(() => {
                setMessages([
                    ...messages,
                    // {sender: 'Machine', content: 'Auto-reply from machine', timestamp: getTimeStamp()},
                    {sender: 'Machine', content: randomSentence, timestamp: getTimeStamp()}
                ]);
            }, 1000);
        }
    }, [messages]);

    const handleKeyPress = (event) => {
        if (event.key === 'Enter'){
            handleSendMessage();
        }
    }

    const handleInputChange = (event) => {
        setInputValue(event.target.value);
    };

    const handleSendMessage = () => {
        if (inputValue.trim() !== '') {
            const newMessage = {
                sender: 'User',
                content: inputValue,
                timestamp: getTimeStamp()
            };
            setMessages([...messages, newMessage]);
            setInputValue('');
        }
    }

    const getTimeStamp = () => {
        const date = new Date();
        return `${date.getHours()}: ${date.getMinutes()}`;
    }

    const generateSentence = (numWords) => {
        const limitNum = 10;
        const words = [
            "The", "quick", "a dog", "run", "climb", "move",
            "a cat", "mewo", 'doggo', 'bird', 'fly',
            'a', 'spider', 'is', 'are', 'does'
        ];
        if(numWords % 10 !== 0){
            console.log("Number of words must be a multiple of 10");
            return ;
        }
        const sentence = [];
        for(let i=0; i < numWords; i+= limitNum){
            const startIndex = Math.floor(Math.random() * (words.length - 10));
            sentence.push(words.slice(startIndex, startIndex + 10).join(' '));
        }

        return sentence.join(' ');
    }

    return (
        <div className="chat-container">
            <div className="messages-container">
                {messages.map((message, index) => (
                    <div key={index} className={`message ${message.sender.toLowerCase()}`}>
                        <div className='message-user'>{message.sender}</div>
                        <div className='message-content'>{message.content}</div>
                        <br/>
                        <div className='message-time'>{message.timestamp}</div>
                    </div>
                ))}
            </div>
            <div className="input-container">
                <input
                    id="text-input"
                    type="text"
                    value={inputValue}
                    onChange={handleInputChange}
                    onKeyPress={handleKeyPress}
                    placeholder="Type a message ..."
                />
                <button onClick={handleSendMessage}></button>
            </div>
        </div>
    );
}

export default ChatApp;