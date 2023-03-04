
//Laravel側から渡された定数を取得する
const json: string = document.getElementById('app')!.dataset.page!;
const constants: any = JSON.parse(json).props.const;

//Laravel側から受け取った定数を取得する
export function getConstant(): any {
    return constants;
}