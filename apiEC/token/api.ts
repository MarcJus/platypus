import { components, paths } from "./generated-schema"

type PickDefined<Object> = Pick<Object, {[Key in keyof Object]: Object[Key] extends undefined ? undefined : Key}[keyof Object]>
type FetchOptions<Method, Query, Params> = RequestInit & {method: Method} & PickDefined<{query: Query, params: Params}>
type ResponseWithStatus<Status extends number> = {responses: Record<Status, {content: {"application/json": any}}>}
type SuccessResponse<Endpoint> = Endpoint extends ResponseWithStatus<200> ? Endpoint["responses"][200]["content"]["application/json"] : null

type EndpointParameter<Endpoint, ParameterType extends string> = Endpoint extends {parameters: Record<ParameterType, object>} ? Endpoint["parameters"][ParameterType] : undefined
type QueryParameters<Endpoint> = EndpointParameter<Endpoint, "query">
type PathParameters<Endpoint> = Endpoint extends {parameters: {path: object}} ? Endpoint["parameters"]["path"] : undefined

async function fetchApi<Path extends keyof paths, Method extends keyof paths[Path]>(path: Path, options: FetchOptions<Method, QueryParameters<paths[Path][Method]>, PathParameters<paths[Path][Method]>>): Promise<SuccessResponse<paths[Path][Method]>>{
    return await fetch(path, options).then(res => res.json())
}

async function DemoDebug(){
    const data = await fetchApi("/pet/findByStatus", {method: "get", query: {status: "available"}})
}