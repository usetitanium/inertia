let uuid = 0

export default {
    beforeCreate() {
        this.uuid = uuid.toString()
        this.id = `id-${uuid}`
        uuid += 1
    },
}
