let id = 0

const useId = () => {
    id += 1

    return `id-${id}`
}

export default useId
