import React from 'react'
import { Station } from 'models/station'
import styled from 'styled-components'

interface Props {
  readonly station: Station
}

const StationControl: React.FC<Props> = ({ station }) =>
  <Wrapper>
    <h3>{ station.name }</h3>
  </Wrapper>

const Wrapper = styled.header(({ theme }) => `
  display: flex;
  align-items: center;
  justify-content: center;
  height: 50px;
`)

export default StationControl
