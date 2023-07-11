import React, { useState } from 'react'
import Form from 'widgets/Form/Form'
import Input from 'widgets/Form/Input'
import styled from 'styled-components'
import { useDispatch, useSelector } from 'react-redux'
import { post, selectIsPosting } from 'features/Messages/Create/slice'

interface Props {
  readonly channelId: string
}

const Create: React.FC<Props> = ({ channelId }) => {
  const [ content, setContent ] = useState<string>('')
  const dispatch = useDispatch()
  const isPosting = useSelector(selectIsPosting)

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    dispatch(post({ content, channelId }))
    setContent('')
  }

  return (
    <Wrapper>
      <Form onSubmit={ e => onSubmitHandler(e) }>
        <Input
          onChange={ e => setContent(e.target.value) }
          name='message'
          placeholder={ 'Say something...' }
          required={ true }
          value={ content }
          disabled={ isPosting }
          type='text'
        />
      </Form>
    </Wrapper>
  )
}

const Wrapper = styled.div(({ theme }) => `
  width: 100%;
  padding: ${ theme.gap.m } ${ theme.gap.l };
`)

export default Create
