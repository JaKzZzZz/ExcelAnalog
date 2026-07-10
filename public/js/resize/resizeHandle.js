import {
    setResizeState
} from "./resizeState.js";


const lineX = document.getElementById("resize-line-x");
const lineY = document.getElementById("resize-line-y");



export function addResizeHandle(td) {


    const handle = document.createElement("div");


    handle.classList.add("resize-handle");


    handle.setAttribute(
        "contenteditable",
        "false"
    );



    handle.addEventListener(
        "mousedown",
        (event)=>{


            event.preventDefault();


            const rect =
                handle.getBoundingClientRect();



            setResizeState({

                startX: rect.left,
                startY: rect.top,

                addRows:0,
                addColumns:0

            });



            lineX.style.display = "block";
            lineY.style.display = "block";

        }
    );


    document
        .querySelector("#spreadsheet")
        .appendChild(handle);

}