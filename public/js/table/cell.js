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


    const key = getCellKey(row, col);


    if (value.trim() === "") {

        delete state.cells[key];

    } else {

        state.cells[key] = value;

    }


}

export function getCellHtmlId(row, col) {
    return `cell-${row}-${col}`;
}

export function removeOutOfBoundsCells() {

    for (const key in state.cells) {

        const [row, col] = key.split("-");


        if (
            Number(row) > state.rows ||
            Number(col) > state.columns
        ) {

            delete state.cells[key];

        }
    }
}