export function getColumnName(index) {


    let name = "";


    while(index >= 0){


        let remainder =
            index % 26;


        name =
            String.fromCharCode(
                65 + remainder
            )
            + name;


        index =
            Math.floor(index / 26)-1;

    }


    return name;

}