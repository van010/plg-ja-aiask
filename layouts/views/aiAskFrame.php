<?php

defined('_JEXEC') or die('Restricted Access');
// do something
?>

<button class="ja-aiassk-btn" id="aiButton">Ai Ask</button>
<!-- The modal -->
<div id="aiModal" class="ai-modal">
    <div class="ai-modal-content">
        <span class="ai-modal-close">&times;</span>
        <h2>Ask Me Anything - GPT 3.5</h2>
        <input type="text" id="textInput" placeholder="Type your text here">
        <button id="submitButton">Submit</button>
        <div id="aiask-response"></div>
    </div>
</div>

<style>
    .ja-aiassk-btn {
        position: fixed;
        bottom: 20px; /* Adjust as needed */
        right: 20px; /* Adjust as needed */
        z-index: 9999;
        background-color: #0084ff; /* Adjust button color */
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 50%;
        padding: 15px 20px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .ja-aiassk-btn:hover {
        transform: scale(1.1); /* Adjust hover scale */
    }

    /* Style for the modal */
    .ai-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4); /* Black background with transparency */
    }

    .ai-modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    .ai-modal-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .ai-modal-close:hover,
    .ai-modal-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>