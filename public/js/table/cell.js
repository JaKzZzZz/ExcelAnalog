import { state } from "../state.js";


export function getCellKey(row,col){

    return `${row}-${col}`;

}



export function getCellValue(row,col){


    const key =
        getCellKey(row,col);


    return state.cells[key] ?? "";

}



export function setCellValue(row,col,value){


    const key =
        getCellKey(row,col);



    state.cells[key] = value;


}