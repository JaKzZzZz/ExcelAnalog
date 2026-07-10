import {
    resizeState,
    clearResizeState
} from "./resizeState.js";


import {
    getCellSize
} from "./resizeUtils.js";


import { state } from "../state.js";

import { saveTable } from "../api/api.js";

import { renderTable } from "../table/renderTable.js";



const lineX =
    document.getElementById("resize-line-x");


const lineY =
    document.getElementById("resize-line-y");




document.addEventListener(
"mousemove",
(event)=>{


    if(!resizeState)
        return;



    const wrapper =
        document
        .querySelector(".table-wrapper")
        .getBoundingClientRect();



    const mouseX =
        event.clientX - wrapper.left;


    const mouseY =
        event.clientY - wrapper.top;



    lineX.style.left =
        `${mouseX}px`;

    lineX.style.top =
        "0px";

    lineX.style.height =
        `${mouseY}px`;



    lineY.style.left =
        "0px";


    lineY.style.top =
        `${mouseY}px`;


    lineY.style.width =
        `${mouseX}px`;



    const cellSize =
        getCellSize();



    const deltaX =
        event.clientX -
        resizeState.startX;


    const deltaY =
        event.clientY -
        resizeState.startY;



    resizeState.addColumns =
        Math.max(
            0,
            Math.floor(
                deltaX /
                cellSize.width
            )
        );


    resizeState.addRows =
        Math.max(
            0,
            Math.floor(
                deltaY /
                cellSize.height
            )
        );


});




document.addEventListener(
"mouseup",
()=>{


    if(!resizeState)
        return;



    state.rows += resizeState.addRows;

    state.columns += resizeState.addColumns;



    lineX.style.display = "none";
    lineY.style.display = "none";



    clearResizeState();



    saveTable();

    renderTable();

});